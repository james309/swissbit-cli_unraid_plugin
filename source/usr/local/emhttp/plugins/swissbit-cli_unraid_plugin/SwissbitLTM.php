<?php
$bin = "/usr/local/bin/sbdm-cli";

// 1. Guard against missing binary
if (!is_executable($bin)) {
    echo "<div class='notice error'>Binary <code>$bin</code> not found or not executable.</div>";
    return;
}

// 2. Execute the LTM command directly
// 2>&1 ensures errors (e.g. no Swissbit drive found) show up in the output array
exec("$bin ltm 2>&1", $rawOutput, $returnCode);

// Filter out Qt iconv warning lines
$output = array_filter($rawOutput, function($line) {
    return strpos($line, 'QIconvCodec') === false;
});
// 3. Render the output
?>
<div class="panel">
  <div class="panel-heading">
    <b>Swissbit Life Time Monitoring (LTM) Telemetry</b>
  </div>
  <div class="panel-body" style="padding: 12px;">
    <?php if ($returnCode !== 0): ?>
      <div class="notice alert" style="margin-bottom: 10px;">
        Command exited with code <?= $returnCode ?>. Verify a compatible Swissbit device is connected.
      </div>
    <?php endif; ?>

    <pre style="background: #1c1c1c; color: #4af626; padding: 12px; border-radius: 4px; overflow-x: auto; font-family: monospace;"><?= htmlspecialchars(implode("\n", $output)) ?></pre>
  </div>
</div>
